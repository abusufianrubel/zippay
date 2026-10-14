<?php

namespace Modules\Agent\Entities;

use App\Models\User;
use Modules\Agent\Entities\Agent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OtpCode extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $fillable = ['user_id', 'agent_id', 'otp_code', 'type', 'created_at', 'updated_at'];

    public function agent()
    {
        return $this->belongsTo(Agent::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function updateOrCreateOtpCode($conditions, $otpCode)
    {
        return self::updateOrCreate($conditions, ['otp_code' => $otpCode]);
    }

    public static function findOtpCode($conditions)
    {
        return self::where($conditions)->first();
    }
}
