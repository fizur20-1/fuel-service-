package com.service;

import com.domain.Cart;
import com.repository.CartRepository;
import org.springframework.stereotype.Service;
import org.springframework.transaction.annotation.Transactional;

import java.util.List;

@Service
@Transactional
public class CartServiceImpl implements CartService{
    private CartRepository cartRepository;


    public CartServiceImpl(CartRepository cartRepository) {
        this.cartRepository = cartRepository;
    }

    @Transactional
    public Cart insert(Cart user) {
        return cartRepository.create(user);
    }

    @Transactional(readOnly = true)
    public Cart get(Long id) {
        return cartRepository.get(id);
    }

    @Transactional(readOnly = true)
    public List<Cart> getAll() {
        return cartRepository.getAll();
    }
}
