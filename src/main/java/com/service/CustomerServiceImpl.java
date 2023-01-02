package com.service;

import com.domain.Cart;
import com.domain.Orders;
import com.domain.Product;
import com.repository.CartRepository;
import com.repository.OrderRepository;
import com.repository.ProductRepository;
import com.repository.UserRepository;
import org.springframework.stereotype.Service;
import org.springframework.transaction.annotation.Transactional;

import java.security.Principal;
import java.sql.Timestamp;
import java.util.List;

@Service
@Transactional
public class CustomerServiceImpl implements CustomerService {
    private UserRepository userRepository;
    private ProductRepository productRepository;
    private CartRepository cartRepository;
    private OrderRepository orderRepository;

    public CustomerServiceImpl(UserRepository userRepository, ProductRepository productRepository,
                               CartRepository cartRepository, OrderRepository orderRepository) {
        this.userRepository = userRepository;
        this.productRepository = productRepository;
        this.cartRepository = cartRepository;
        this.orderRepository = orderRepository;
    }

    @Transactional(readOnly = true)
    public List<Product> getAll() {
        return productRepository.getAll();
    }

    @Transactional
    public List<Cart> getAllByCartId(String cart_id) {
        return cartRepository.getAllByCartId(cart_id);
    }

    @Transactional
    public Cart insertCart(Cart cart) {
        return cartRepository.create(cart);
    }

    @Transactional
    public boolean deleteCart(Long product_id, String cart_id) {
        Cart tempCart = cartRepository.getByProductId(product_id, cart_id);
        return cartRepository.delete(tempCart.getId());
    }

    @Transactional
    public Orders order(Orders orders, Principal principal) {
        orders.setCustomer_id(getUserId(principal));
        orders.setTimestamp(String.valueOf(new Timestamp(System.currentTimeMillis()).getTime() / 1000));
        List<Cart> cartList = getAllByCartId(String.valueOf(orders.getId()));
        Double tempCost = 0.0;
        for (Cart cart : cartList) {
            tempCost += cart.getProduct().getPrice();
        }
        orders.setTotal_cost(tempCost);
        orders.setStatus("PENDING");
        return orderRepository.create(orders);
    }

    @Transactional
    public Long getUserId(Principal principal) {
        return userRepository.getByUsername(principal.getName()).getId();
    }

    @Transactional
    public List<Orders> getOrders(Principal principal){
       return orderRepository.getByCustomerId(getUserId(principal));
    }
}
