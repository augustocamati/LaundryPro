<?php

namespace App\Models;

use App\Core\Model;

class Pedido extends Model {
    protected ?int $id = null;
    protected int $clienteId;
    protected ?int $funcionarioId = null;
    protected ?string $dataPedido = null;
    protected string $dataEntregaPrevista;
    protected ?string $dataEntregaReal = null;
    protected string $status = 'Pendente';
    protected float $valorTotal = 0.00;
    protected ?string $observacoes = null;
    protected ?string $createdAt = null;
    protected ?string $updatedAt = null;

    public function getId(): ?int {
        return $this->id;
    }

    public function setId(?int $id): self {
        $this->id = $id;
        return $this;
    }

    public function getClienteId(): int {
        return $this->clienteId;
    }

    public function setClienteId(int $clienteId): self {
        $this->clienteId = $clienteId;
        return $this;
    }

    public function getFuncionarioId(): ?int {
        return $this->funcionarioId;
    }

    public function setFuncionarioId(?int $funcionarioId): self {
        $this->funcionarioId = $funcionarioId;
        return $this;
    }

    public function getDataPedido(): ?string {
        return $this->dataPedido;
    }

    public function setDataPedido(?string $dataPedido): self {
        $this->dataPedido = $dataPedido;
        return $this;
    }

    public function getDataEntregaPrevista(): string {
        return $this->dataEntregaPrevista;
    }

    public function setDataEntregaPrevista(string $dataEntregaPrevista): self {
        $this->dataEntregaPrevista = $dataEntregaPrevista;
        return $this;
    }

    public function getDataEntregaReal(): ?string {
        return $this->dataEntregaReal;
    }

    public function setDataEntregaReal(?string $dataEntregaReal): self {
        $this->dataEntregaReal = $dataEntregaReal;
        return $this;
    }

    public function getStatus(): string {
        return $this->status;
    }

    public function setStatus(string $status): self {
        $this->status = $status;
        return $this;
    }

    public function getValorTotal(): float {
        return $this->valorTotal;
    }

    public function setValorTotal(float $valorTotal): self {
        $this->valorTotal = $valorTotal;
        return $this;
    }

    public function getObservacoes(): ?string {
        return $this->observacoes;
    }

    public function setObservacoes(?string $observacoes): self {
        $this->observacoes = $observacoes;
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
