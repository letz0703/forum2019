<?php
/**
 * Created by letz.
 * User: letz
 * Date: 2019. 6. 6.
 * Time: AM 3:22.
 */

namespace App;

trait RecordActivity
{
    protected static function bootRecordActivity()
    {
        if (auth()->guest()) {
            return;
        }

        foreach (self::getActivitiesToRecord() as $event) {
            static::$event(function ($model) use ($event) {
                $model->recordActivity($event);
            });
        }

        self::deleting(function ($model) {
            $model->activity()->delete();
        });
    }

    protected static function getActivitiesToRecord()
    {
        return ['created'];
    }

    protected function recordActivity($eventType)
    {
        $this->activity()->create([
            'user_id' => auth()->id(),
            //'type'         => 'created_thread',
            'type'    => $this->getEventType($eventType),
            //Activity::create([
            //    'user_id'      => auth()->id(),
            //    //'type'         => 'created_thread',
            //    'type'         => $this->getEventType($eventType),
            //
            //'subject_id'   => $this->id,
            ////'subject_type' => get_class($this)
            //'subject_type' => get_class($this)
        ]);
    }

    public function activity()
    {
        return $this->morphMany(Activity::class, 'subject');
    }

    /**
     * created_thread.
     *
     * @param $eventType
     *
     * @return string like 'created'
     */
    protected function getEventType($eventType): string
    {
        $className = strtolower(class_basename($this));

        //return $eventType . '_' . strtolower(class_basename($this));
        return "{$eventType}_{$className}";
    }
}
