package com.service;

import com.domain.Cart;
import com.domain.Orders;
import com.domain.Product;

import java.security.Principal;
import java.util.List;

public interface CustomerService {
    public List<Product> getAll();

    public List<Cart> getAllByCartId(String cart_id);

    public Cart insertCart(Cart cart);

    public boolean deleteCart(Long product_id, String cart_id);

    public Orders order(Orders orders, Principal principal);

    public Long getUserId(Principal principal);

    public List<Orders> getOrders(Principal principal);
}
