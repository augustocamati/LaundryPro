<?php

namespace App\Models;

use App\Core\Model;

class Log extends Model {
    protected ?int $id = null;
    protected ?int $usuarioId = null;
    protected string $acao;
    protected string $descricao;
    protected ?string $ipAddress = null;
    protected ?string $createdAt = null;

    public function getId(): ?int {
        return $this->id;
    }

    public function setId(?int $id): self {
        $this->id = $id;
        return $this;
    }

    public function getUsuarioId(): ?int {
        return $this->usuarioId;
    }

    public function setUsuarioId(?int $usuarioId): self {
        $this->usuarioId = $usuarioId;
        return $this;
    }

    public function getAcao(): string {
        return $this->acao;
    }

    public function setAcao(string $acao): self {
        $this->acao = $acao;
        return $this;
    }

    public function getDescricao(): string {
        return $this->descricao;
    }

    public function setDescricao(string $descricao): self {
        $this->descricao = $descricao;
        return $this;
    }

    public function getIpAddress(): ?string {
        return $this->ipAddress;
    }

    public function setIpAddress(?string $ipAddress): self {
        $this->ipAddress = $ipAddress;
        return $this;
    }

    public function getCreatedAt(): ?string {
        return $this->createdAt;
    }

    public function setCreatedAt(?string $createdAt): self {
        $this->createdAt = $createdAt;
        return $this;
    }
}
