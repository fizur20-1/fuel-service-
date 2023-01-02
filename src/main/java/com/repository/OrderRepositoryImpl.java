package com.repository;

import com.domain.Orders;
import org.hibernate.Query;
import org.hibernate.Session;
import org.hibernate.SessionFactory;
import org.springframework.stereotype.Repository;

import java.util.List;

@Repository
public class OrderRepositoryImpl implements OrderRepository {

    private SessionFactory sessionFactory;

    public OrderRepositoryImpl(SessionFactory sessionFactory) {
        this.sessionFactory = sessionFactory;
    }

    public List<Orders> getAll() {
        Session session = sessionFactory.getCurrentSession();
        Query<Orders> userQuery = session.createQuery("from Orders", Orders.class);
        return userQuery.getResultList();
    }

    public Orders create(Orders order) {
        Session session = sessionFactory.getCurrentSession();
        session.save(order);
        return order;
    }

    public Orders get(Long id) {
        Session session = sessionFactory.getCurrentSession();
        return session.get(Orders.class, id);
    }

    public Orders update(Orders order) {
        Session session = sessionFactory.getCurrentSession();
        session.saveOrUpdate(order);
        return order;
    }

    public boolean delete(Long id) {
        Session session = sessionFactory.getCurrentSession();
        Orders order = get(id);
        if (order != null) {
            session.delete(order);
            return true;
        } else return false;
    }

    public List<Orders> getByCustomerId(Long id) {
        Session session = sessionFactory.getCurrentSession();
        Query<Orders> userQuery = session.createQuery("from Orders where customer_id = :id", Orders.class);
        userQuery.setParameter("id", id);
        return userQuery.getResultList();
    }
    public List<Orders> getOrdersStatus( String status){
        Session session = sessionFactory.getCurrentSession();
        Query<Orders> userQuery = session.createQuery("from Orders where status = :status", Orders.class);
        userQuery.setParameter("status", status);
        return userQuery.getResultList();
    }

    public List<Orders> getOrdersStatusById(Long id,String status){
        Session session = sessionFactory.getCurrentSession();
        Query<Orders> userQuery = session.createQuery("from Orders where  status = :status", Orders.class);
        userQuery.setParameter("status", status);
        return userQuery.getResultList();
    }
}

