<?php

namespace App\Models;

use App\Core\Model;

class Funcionario extends Model {
    protected ?int $id = null;
    protected int $usuarioId;
    protected string $cargo;
    protected float $salario;
    protected string $dataAdmissao;
    protected ?string $createdAt = null;
    protected ?string $updatedAt = null;

    public function getId(): ?int {
        return $this->id;
    }

    public function setId(?int $id): self {
        $this->id = $id;
        return $this;
    }

    public function getUsuarioId(): int {
        return $this->usuarioId;
    }

    public function setUsuarioId(int $usuarioId): self {
        $this->usuarioId = $usuarioId;
        return $this;
    }

    public function getCargo(): string {
        return $this->cargo;
    }

    public function setCargo(string $cargo): self {
        $this->cargo = $cargo;
        return $this;
    }

    public function getSalario(): float {
        return $this->salario;
    }

    public function setSalario(float $salario): self {
        $this->salario = $salario;
        return $this;
    }

    public function getDataAdmissao(): string {
        return $this->dataAdmissao;
    }

    public function setDataAdmissao(string $dataAdmissao): self {
        $this->dataAdmissao = $dataAdmissao;
        return $this;
    }

    public function getCreatedAt(): ?string {
        return $this->createdAt;
    }

    public function setCreatedAt(?string $createdAt): self {
        $this->createdAt = $createdAt;
        return $this;
    }

    public function getUpdatedAt(): ?string {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?string $updatedAt): self {
        $this->updatedAt = $updatedAt;
        return $this;
    }
}
