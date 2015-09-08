<?php

namespace App\Models\PPP;

use T4\Orm\Model;

class Report extends Model
{
    public static function getResults($data)
    {
        $result = [];

        foreach ($data as $v) {
            if (empty($result[$v['col1']])) {
                $result[$v['col1']] = ['items' => [], 'to' => 0, 'from' => 0, 'result' => 0];
            }
            if (empty($result[$v['col1']]['items'][$v['col2']])) {
                $result[$v['col1']]['items'][$v['col2']] = ['items' => [], 'to' => 0, 'from' => 0, 'result' => 0];
            }
            if (empty($result[$v['col1']]['items'][$v['col2']]['items'][$v['col3']])) {
                $result[$v['col1']]['items'][$v['col2']]['items'][$v['col3']] = ['to' => 0, 'from' => 0, 'result' => 0];
            }
            if ($v['qty'] > 0) {
                $result[$v['col1']]['to'] += $v['qty'];
                $result[$v['col1']]['items'][$v['col2']]['to'] += $v['qty'];
                $result[$v['col1']]['items'][$v['col2']]['items'][$v['col3']]['to'] += $v['qty'];
            } else {
                $result[$v['col1']]['from'] -= $v['qty'];
                $result[$v['col1']]['items'][$v['col2']]['from'] -= $v['qty'];
                $result[$v['col1']]['items'][$v['col2']]['items'][$v['col3']]['from'] -= $v['qty'];
            }
            $result[$v['col1']]['result'] += $v['qty'];
            $result[$v['col1']]['items'][$v['col2']]['result'] += $v['qty'];
            $result[$v['col1']]['items'][$v['col2']]['items'][$v['col3']]['result'] += $v['qty'];
        }

        foreach ($result as $k => $v) {
            foreach ($v['items'] as $k2 => $v2) {
                foreach ($v2['items'] as $k3 => $v3) {
                    if (0 == $v3['result']) {
                        unset($result[$k]['items'][$k2]['items'][$k3]);
                    }
                }
                if (0 == $v2['result']) {
                    unset($result[$k]['items'][$k2]);
                }
            }
            if (0 == $v['result']) {
                unset($result[$k]);
            }
        }

        return $result;
    }
}