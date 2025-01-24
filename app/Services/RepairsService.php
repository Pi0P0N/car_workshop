<?php

namespace App\Services;

use App\Models\Repairs;
use App\Models\RepairType;

class RepairsService
{
	public function getAllRepairs()
	{
		return Repairs::all();
	}

    public function getAvailableRepairTimes($date, $repairTypeId, $repairId = null)
    {
        $repairsQuery = Repairs::where('scheduled_date', $date);
        if ($repairId) {
            $repairsQuery->where('id', '!=', $repairId);
        }
        $repairs = $repairsQuery->get();
        $repairType = RepairType::find($repairTypeId);
        $repairDuration = $repairType->duration;
    
        $openingHour = 9;
        $closingHour = 17;
    
        $availableTimes = [];
        for ($i = $openingHour; $i < $closingHour; $i++) {
            for ($j = 0; $j < 60; $j += 30) {
                $time = sprintf('%02d:%02d', $i, $j);
                $isAvailable = true;
                $timeObj = \DateTime::createFromFormat('H:i', $time);
                $repairEndObj = clone $timeObj;
                $repairEndObj->modify("+{$repairDuration} minutes");
    
                foreach ($repairs as $repair) {
                    $repairStart = $repair->scheduled_time;
                    $repairStartObj = \DateTime::createFromFormat('H:i:s', $repairStart);
                    $repairEnd = date('H:i', strtotime($repairStart) + $repair->repairType->duration * 60);
                    $repairEndObjExisting = \DateTime::createFromFormat('H:i', $repairEnd);
    
                    if (($timeObj >= $repairStartObj && $timeObj < $repairEndObjExisting) ||
                        ($repairEndObj > $repairStartObj && $repairEndObj <= $repairEndObjExisting)) {
                        $isAvailable = false;
                        break;
                    }
                }
    
                if ($isAvailable && $repairEndObj->format('H:i') <= sprintf('%02d:00', $closingHour)) {
                    $availableTimes[] = $time;
                }
            }
        }
    
        return $availableTimes;
    }

    public function getRepairsForDate($date)
    {
        return Repairs::where('scheduled_date', $date)->orderBy('scheduled_time')->get();
    }
}