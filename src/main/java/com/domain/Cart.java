package com.domain;

import javax.persistence.*;
import javax.validation.constraints.NotNull;

@Entity
@Table(name = "cart")
public class Cart {
    @Id
    @GeneratedValue(strategy = GenerationType.IDENTITY)
    private Long id;

    @NotNull
    @Column(name = "cart_id")
    private String cart_id;
    //    @NotNull
//    @Column(name = "product_id")
//    private Long product_id;
    @ManyToOne()
    @JoinColumn(name = "product_id")
    private Product product;

    public Long getId() {
        return id;
    }

    public void setId(Long id) {
        this.id = id;
    }

    public String getCart_id() {
        return cart_id;
    }

    public void setOrder_id(String cart_id) {
        this.cart_id = cart_id;
    }

//    public Long getProduct_id() {
//        return product_id;
//    }
//
//    public void setProduct_id(Long product_id) {
//        this.product_id = product_id;
//    }

    public Product getProduct() {
        return product;
    }

    public void setProduct(Product product) {
        this.product = product;
    }
}