<?php

namespace App\Models;

use App\Core\Model;

class Pagamento extends Model {
    protected ?int $id = null;
    protected int $pedidoId;
    protected float $valor;
    protected string $metodoPagamento;
    protected string $status = 'Pendente';
    protected ?string $dataPagamento = null;
    protected ?string $createdAt = null;
    protected ?string $updatedAt = null;

    public function getId(): ?int {
        return $this->id;
    }

    public function setId(?int $id): self {
        $this->id = $id;
        return $this;
    }

    public function getPedidoId(): int {
        return $this->pedidoId;
    }

    public function setPedidoId(int $pedidoId): self {
        $this->pedidoId = $pedidoId;
        return $this;
    }

    public function getValor(): float {
        return $this->valor;
    }

    public function setValor(float $valor): self {
        $this->valor = $valor;
        return $this;
    }

    public function getMetodoPagamento(): string {
        return $this->metodoPagamento;
    }

    public function setMetodoPagamento(string $metodoPagamento): self {
        $this->metodoPagamento = $metodoPagamento;
        return $this;
    }

    public function getStatus(): string {
        return $this->status;
    }

    public function setStatus(string $status): self {
        $this->status = $status;
        return $this;
    }

    public function getDataPagamento(): ?string {
        return $this->dataPagamento;
    }

    public function setDataPagamento(?string $dataPagamento): self {
        $this->dataPagamento = $dataPagamento;
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
