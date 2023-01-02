package com.domain;

import javax.persistence.*;
import javax.validation.constraints.NotNull;

@Entity
@Table(name = "orders")
public class Orders {
    @Id
    private Long id;
    @NotNull
    @Column(name = "customer_id")
    private Long customer_id;
    @NotNull
    @Column(name = "total_cost")
    private Double total_cost;
    @NotNull
    @Column(name = "timestamp")
    private String timestamp;
    @NotNull
    @Column(name = "status")
    private String status;

    public Long getId() {
        return id;
    }

    public void setId(Long id) {
        this.id = id;
    }

    public Long getCustomer_id() {
        return customer_id;
    }

    public void setCustomer_id(Long customer_id) {
        this.customer_id = customer_id;
    }

    public Double getTotal_cost() {
        return total_cost;
    }

    public void setTotal_cost(Double total_cost) {
        this.total_cost = total_cost;
    }

    public String getTimestamp() {
        return timestamp;
    }

    public void setTimestamp(String timestamp) {
        this.timestamp = timestamp;
    }

    public String getStatus() {
        return status;
    }

    public void setStatus(String status) {
        this.status = status;
    }
}
