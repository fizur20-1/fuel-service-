package com.repository;

import com.domain.Product;

import java.util.List;

public interface ProductRepository {
    public List<Product> getAll() ;

    public Product create(Product product) ;

    public Product get(Long id) ;

    public Product update(Product product) ;

    public boolean delete(Long id) ;

    public Product getByName(String name) ;
}
