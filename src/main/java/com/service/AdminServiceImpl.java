package com.service;

import com.domain.Orders;
import com.domain.Product;
import com.domain.User;
import com.repository.OrderRepository;
import com.repository.ProductRepository;
import com.repository.UserRepository;
import org.springframework.security.crypto.password.PasswordEncoder;
import org.springframework.stereotype.Service;
import org.springframework.transaction.annotation.Transactional;

import java.util.List;

@Service
@Transactional
public class AdminServiceImpl implements AdminService {
    private UserRepository userRepository;
    private ProductRepository productRepository;
    private OrderRepository orderRepository;
    private PasswordEncoder passwordEncoder;

    public AdminServiceImpl(UserRepository userRepository, ProductRepository productRepository,
                            OrderRepository orderRepository, PasswordEncoder passwordEncoder) {
        this.userRepository = userRepository;
        this.passwordEncoder = passwordEncoder;
        this.productRepository = productRepository;
        this.orderRepository = orderRepository;
    }

    @Transactional(readOnly = true)
    public List<User> getAllUsers() {
        return userRepository.getAll();
    }

    @Transactional
    public User insertUser(User user) {
        user.setPassword(passwordEncoder.encode(user.getPassword()));
        return userRepository.create(user);
    }

    @Transactional
    public User updateUser(User user) {
        return userRepository.update(user);
    }

    @Transactional
    public boolean deleteUser(Long id) {
        return userRepository.delete(id);
    }

    @Transactional(readOnly = true)
    public List<Product> getAllProducts() {
        return productRepository.getAll();
    }

    @Transactional
    public Product insertProduct(Product product) {
        return productRepository.create(product);
    }

    @Transactional
    public Product updateProduct(Product product) {
        return productRepository.update(product);
    }

    @Transactional
    public boolean deleteProduct(Long id) {
        return productRepository.delete(id);
    }

    @Transactional(readOnly = true)
    public List<Orders> getAllOrders() {
        return orderRepository.getAll();
    }

    @Transactional
    public Orders insertOrder(Orders order) {
        return orderRepository.create(order);
    }

    @Transactional
    public Orders updateOrder(Orders order) {
        return orderRepository.update(order);
    }

    @Transactional
    public boolean deleteOrder(Long id) {
        return orderRepository.delete(id);
    }
}
