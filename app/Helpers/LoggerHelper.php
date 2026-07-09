<?php

namespace App\Helpers;

use App\Core\Auth;
use App\Models\Log;
use App\DAO\LogDAO;

class LoggerHelper {
    /**
     * Regista uma ação no sistema de logs.
     *
     * @param string $acao
     * @param string $descricao
     * @return void
     */
    public static function log(string $acao, string $descricao): void {
        $userId = Auth::id();
        $ip = $_SERVER['REMOTE_ADDR'] ?? null;
        
        $log = new Log();
        $log->setUsuarioId($userId);
        $log->setAcao($acao);
        $log->setDescricao($descricao);
        $log->setIpAddress($ip);
        
        $dao = new LogDAO();
        $dao->create($log);
    }
}
