package com.service;

import com.domain.Cart;
import com.domain.Orders;

import java.security.Principal;
import java.util.List;

public interface DeliveryService {
    public List<Orders> getOrdersByStatus(String status);

    public Long getUserId(Principal principal);

    //public List<Orders> getMyDeliveryByStatus(Principal principal, String status);

    public List<Cart> getAllByCartId(String cart_id);

    public Object getCustomerInfo(Long customer_id);

    public Orders acceptDeliveryById(Long delivery_id);
}
