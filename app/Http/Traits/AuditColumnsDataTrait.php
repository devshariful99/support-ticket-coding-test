<?php

namespace App\Http\Traits;

trait AuditColumnsDataTrait
{
    private function AdminAuditColumnsData($data)
    {
        $data->creating_time = timeFormat($data->created_at);
        $data->updating_time = $data->created_at != $data->updated_at ? timeFormat($data->updated_at) : 'null';
        $data->created_by = creater_name($data->creater_admin);
        $data->updated_by = updater_name($data->updater_admin);
    }
    private function UserAuditColumnsData($data)
    {
        $data->creating_time = timeFormat($data->created_at);
        $data->updating_time = $data->created_at != $data->updated_at ? timeFormat($data->updated_at) : 'null';
        $data->created_by = creater_name($data->creater_user);
        $data->updated_by = updater_name($data->updater_user);
    }
    private function MorphAuditColumnsData($data)
    {
        $data->creating_time = timeFormat($data->created_at);
        $data->updating_time = $data->created_at != $data->updated_at ? timeFormat($data->updated_at) : 'null';
        $data->created_by = creater_name($data->creater);
        $data->updated_by = updater_name($data->updater);
    }
    private function StatusData($data)
    {
        $data->statusBadgeBg = $data->status ? $data->getStatusBadgeBg() : '';
        $data->statusBadgeTitle = $data->status ? $data->getStatusBadgeTitle() : '';
        $data->statusBtnBg = $data->status ? $data->getStatusBtnBg() : '';
        $data->statusBtnTitle = $data->status ? $data->getStatusBtnTitle() : '';
    }
}
