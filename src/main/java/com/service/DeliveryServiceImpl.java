package com.service;

import com.domain.Cart;
import com.domain.Orders;
import com.domain.User;
import com.repository.CartRepository;
import com.repository.OrderRepository;
import com.repository.ProductRepository;
import com.repository.UserRepository;
import org.springframework.stereotype.Service;
import org.springframework.transaction.annotation.Transactional;

import java.security.Principal;
import java.util.HashMap;
import java.util.List;
import java.util.Map;

@Service
@Transactional
public class DeliveryServiceImpl implements DeliveryService {
    private UserRepository userRepository;
    private ProductRepository productRepository;
    private CartRepository cartRepository;
    private OrderRepository orderRepository;

    public DeliveryServiceImpl(UserRepository userRepository, ProductRepository productRepository,
                               CartRepository cartRepository, OrderRepository orderRepository) {
        this.userRepository = userRepository;
        this.productRepository = productRepository;
        this.cartRepository = cartRepository;
        this.orderRepository = orderRepository;
    }

    @Transactional(readOnly = true)
    public List<Orders> getOrdersByStatus(String status) {
        return orderRepository.getOrdersStatus(status);
    }

    @Transactional(readOnly = true)
    public Long getUserId(Principal principal) {
        return userRepository.getByUsername(principal.getName()).getId();
    }

//    @Transactional
//    public List<Orders> getMyDeliveryByStatus(Principal principal, String status) {
//        return orderRepository.getOrdersStatusById(getUserId(principal), status);
//    }

    @Transactional(readOnly = true)
    public List<Cart> getAllByCartId(String cart_id) {
        return cartRepository.getAllByCartId(cart_id);
    }

    @Transactional
    public Object getCustomerInfo(Long customer_id) {
        User customer = userRepository.get(customer_id);
        Map<String, String> map = new HashMap<>();
        map.put("enabled", customer.isEnabled() ? "enabled" : "disabled");
        map.put("phone", customer.getPhone());
        map.put("name", customer.getUsername());

        return map;
    }

    @Transactional
    public Orders acceptDeliveryById(Long delivery_id) {
        Orders order = orderRepository.get(delivery_id);
        order.setStatus("DELIVERING");
        return orderRepository.update(order);
    }
}
