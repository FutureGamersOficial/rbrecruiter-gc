<?php

namespace App;

use App\Exceptions\AbsenceNotActionableException;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Absence extends Model
{
    use HasFactory;

    protected $fillable = [
      'requesterID',
      'start',
      'predicted_end',
      'available_assist',
      'reason',
      'status',
      'reviewer',
      'reviewed_date'
    ];

    public function requester(): BelongsTo
    {
        return $this->belongsTo('App\User', 'requesterID', 'id');
    }


    /**
     * Determines whether this model can be setApproved(), setDeclined() or setCancelled()
     *
     * @param bool $toCancel Switch the check to cancellability check
     * @return bool
     */
    public function isActionable(bool $toCancel = false): bool
    {
        if ($toCancel)
        {
            return in_array($this->getRawOriginal('status'), ['PENDING', 'APPROVED']);
        }

        return $this->getRawOriginal('status') == 'PENDING';
    }


    /**
     * Sets the Absence's status as approved
     *
     * @return Absence
     * @throws AbsenceNotActionableException
     */
    public function setApproved(): Absence
    {
        if ($this->isActionable())
        {
            return tap($this)->update([
                'status' => 'APPROVED'
            ]);
        }

        throw new AbsenceNotActionableException('This absence is not actionable!');
    }


    /**
     * Sets the absence's status as declined
     *
     * @return Absence
     * @throws AbsenceNotActionableException
     */
    public function setDeclined(): Absence
    {
        if ($this->isActionable()) {
            return tap($this)->update([
                'status' => 'DECLINED'
            ]);
        }

        throw new AbsenceNotActionableException('This absence is not actionable!');
    }


    /**
     * Sets the absence's status as cancelled
     *
     * @return Absence
     * @throws AbsenceNotActionableException Thrown when the switch to this status would be invalid
     */
    public function setCancelled(): Absence
    {
        if ($this->isActionable(true)) {
            return tap($this)->update([
                'status' => 'CANCELLED'
            ]);
        }

        throw new AbsenceNotActionableException('This absence is not actionable!');
    }

    /**
     * Sets the absence's status as ended
     *
     * @return Absence
     */
    public function setEnded(): Absence
    {
        return tap($this)->update([
            'status' => 'ENDED'
        ]);
    }


    // Look out when retrieving this value;
    //If you need the unaltered version of it, either adapt to its formatting or call getRawOriginal()
    protected function status(): Attribute {
        return Attribute::make(
            get: fn($value) => ucfirst(strtolower($value))
        );
    }

}

