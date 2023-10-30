<?php
/**
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Bex\Monolog\Handler;

use Bex\Monolog\Formatter\BitrixFormatter;
use CEventLog;
use Monolog\Handler\AbstractProcessingHandler;
use Monolog\Level;
use Monolog\LogRecord;

/**
 * Monolog handler for the event log of Bitrix CMS.
 *
 * @author Nik Samokhvalov <nik@samokhvalov.info>
 */
class BitrixHandler extends AbstractProcessingHandler
{
    private string $event;
    private string $module;
    private string $siteId;

    /**
     * @param string $event Type of event in the event log of Bitrix.
     * @param string $module Code of the module in Bitrix.
     * @param int|level $level The minimum logging level at which this handler will be triggered.
     * @param bool $bubble Whether the messages that are handled can bubble up the stack or not.
     */
    public function __construct($event = null, $module = null, int|level $level = Level::Debug, bool $bubble = true)
    {
        parent::__construct($level, $bubble);

        $this->setEvent($event);
        $this->setModule($module);
    }

    /**
     * {@inheritdoc}
     */
    protected function write(LogRecord $record): void
    {
        CEventLog::Log(
            $record['formatted']['level'],
            $this->getEvent(),
            $this->getModule(),
            $record['formatted']['item_id'],
            $record['formatted']['message'],
            $this->getSite()
        );
    }

    /**
     * {@inheritdoc}
     */
    protected function getDefaultFormatter(): BitrixFormatter
    {
        return new BitrixFormatter();
    }

    /**
     * Sets event type for log of Bitrix.
     *
     * @param string $event
     */
    public function setEvent(string $event): void
    {
        $this->event = $event;
    }

    /**
     * Gets event type.
     *
     * @return string
     */
    public function getEvent(): string
    {
        return $this->event;
    }

    /**
     * Sets module for log of Bitrix.
     *
     * @param string $module
     */
    public function setModule(string $module): void
    {
        $this->module = $module;
    }

    /**
     * Gets module.
     *
     * @return string
     */
    public function getModule(): string
    {
        return $this->module;
    }

    /**
     * Sets site ID for log of Bitrix.
     *
     * @param string $siteId
     */
    public function setSite(string $siteId): void
    {
        $this->siteId = $siteId;
    }

    /**
     * Gets site ID.
     *
     * @return string
     */
    public function getSite(): string
    {
        return $this->siteId;
    }
}
