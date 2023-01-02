package com.repository;

import com.domain.Product;
import org.hibernate.Query;
import org.hibernate.Session;
import org.hibernate.SessionFactory;
import org.springframework.stereotype.Repository;

import java.util.List;

@Repository
public class ProductRepositoryImpl implements ProductRepository {

    private SessionFactory sessionFactory;

    public ProductRepositoryImpl(SessionFactory sessionFactory) {
        this.sessionFactory = sessionFactory;
    }

    public List<Product> getAll() {
        Session session = sessionFactory.getCurrentSession();
        Query<Product> userQuery = session.createQuery("from Product", Product.class);
        return userQuery.getResultList();
    }

    public Product create(Product product) {
        Session session = sessionFactory.getCurrentSession();
        session.save(product);
        return product;
    }

    public Product get(Long id) {
        Session session = sessionFactory.getCurrentSession();
        return session.get(Product.class, id);
    }

    public Product update(Product product) {
        Session session = sessionFactory.getCurrentSession();
        session.saveOrUpdate(product);
        return product;
    }

    public boolean delete(Long id) {
        Session session = sessionFactory.getCurrentSession();
        Product product = get(id);
        if (product != null) {
            session.delete(product);
            return true;
        } else return false;
    }

    public Product getByName(String name) {
        Session session = sessionFactory.getCurrentSession();
        Query<Product> userQuery = session.createQuery("from Product where name = :name", Product.class);
        userQuery.setParameter("name", name);
        return userQuery.getSingleResult();
    }
}

