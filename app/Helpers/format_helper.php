<?php

function tanggal($timestamp = 0)
{
    if (!$timestamp) {
        return "";
    }
    return date('d/m/Y H:i', $timestamp);
}

function tanggalN($timestamp = 0)
{
    if (!$timestamp) {
        return "";
    }
    return date('m/d/Y h:i A', $timestamp);
}

function pilgan($index = 0)
{
    $pilihan = ['[kosong]', 'A', 'B', 'C', 'D', 'E'];
    return $pilihan[$index];
}
