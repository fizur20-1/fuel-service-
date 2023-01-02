package com.repository;

import com.domain.Orders;

import java.util.List;

public interface OrderRepository {
    public List<Orders> getAll();

    public Orders create(Orders order);

    public Orders get(Long id);

    public Orders update(Orders order);

    public boolean delete(Long id);

    public List<Orders> getByCustomerId(Long id);

    public List<Orders> getOrdersStatus(String status);

    public List<Orders> getOrdersStatusById(Long id, String status);
}
