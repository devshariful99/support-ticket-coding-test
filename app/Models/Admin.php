<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;

class Admin extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    protected $fillable = [
        'name',
        'email',
        'password',
        'email_sent_at',
        'email_verified_at',
        'status',
        'created_by',
        'updated_by',
        'deleted_by',
    ];
    protected $hidden = [
        'password',
        'remember_token',
    ];
    protected $casts = [
        'email_verified_at' => 'datetime',
        'email_sent_at' => 'datetime',
        'status' => 'boolean',
        'password' => 'hashed',
    ];



    public function creater_admin()
    {
        return $this->belongsTo(Admin::class, 'created_by');
    }
    public function updater_admin()
    {
        return $this->belongsTo(Admin::class, 'updated_by');
    }
    public function deleter_admin()
    {
        return $this->belongsTo(Admin::class, 'deleted_by');
    }

    public function getStatusBadgeTitle()
    {
        if ($this->status == 1) {
            return 'Active';
        } else {
            return 'Deactive';
        }
    }
    public function getStatusBtnTitle()
    {
        if ($this->status == 1) {
            return 'Deactive';
        } else {
            return 'Active';
        }
    }

    public function getStatusBtnBg()
    {
        if ($this->status == 1) {
            return 'btn btn-danger';
        } else {
            return 'btn btn-success';
        }
    }
    public function getStatusBadgeBg()
    {
        if ($this->status == 1) {
            return 'badge badge-success';
        } else {
            return 'badge badge-warning';
        }
    }
    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }
}
