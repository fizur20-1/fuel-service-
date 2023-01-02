package com.service;

import com.domain.Cart;
import org.springframework.transaction.annotation.Transactional;

import java.util.List;

public interface CartService {

    public Cart insert(Cart user);

    public Cart get(Long id);

    public List<Cart> getAll();
}
