package com.repository;

import com.domain.Cart;

import java.util.List;

public interface CartRepository {
    public List<Cart> getAll();

    public List<Cart> getAllByCartId(String cart_id);

    public Cart create(Cart cart);

    public Cart get(Long id);

    public Cart getByProductId(Long product_id, String cart_id);

    public Cart update(Cart cart);

    public boolean delete(Long id);
}
