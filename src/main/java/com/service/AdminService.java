package com.service;

import com.domain.Orders;
import com.domain.Product;
import com.domain.User;

import java.util.List;

public interface AdminService {
    public List<User> getAllUsers();

    public User insertUser(User user);

    public User updateUser(User user);

    public boolean deleteUser(Long id);

    public List<Product> getAllProducts();

    public Product insertProduct(Product product);

    public Product updateProduct(Product product);

    public boolean deleteProduct(Long id);

    public List<Orders> getAllOrders();

    public Orders insertOrder(Orders order);

    public Orders updateOrder(Orders order);

    public boolean deleteOrder(Long id);
}
