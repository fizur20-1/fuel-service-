package com.repository;

import com.domain.Cart;
import com.domain.Product;
import org.hibernate.Query;
import org.hibernate.Session;
import org.hibernate.SessionFactory;
import org.springframework.stereotype.Repository;

import java.util.List;

@Repository
public class CartRepositoryImpl implements CartRepository {

    private SessionFactory sessionFactory;

    public CartRepositoryImpl(SessionFactory sessionFactory) {
        this.sessionFactory = sessionFactory;
    }

    public List<Cart> getAll() {
        Session session = sessionFactory.getCurrentSession();
        Query<Cart> cartQuery = session.createQuery("from Cart", Cart.class);
        return cartQuery.getResultList();
    }

    public List<Cart> getAllByCartId(String cart_id) {
        Session session = sessionFactory.getCurrentSession();
        Query<Cart> cartQuery = session.createQuery("from Cart where cart_id = :cart_id", Cart.class);
        cartQuery.setParameter("cart_id", cart_id);
        return cartQuery.getResultList();
    }

    public Cart create(Cart cart) {
        Session session = sessionFactory.getCurrentSession();
        session.save(cart);
        return cart;
    }

    public Cart get(Long id) {
        Session session = sessionFactory.getCurrentSession();
        return session.get(Cart.class, id);
    }

    public Cart getByProductId(Long product_id, String cart_id) {
        Session session = sessionFactory.getCurrentSession();
        Query<Cart> cartQuery = session.createQuery("from Cart where cart_id = :cart_id and product_id = :product_id", Cart.class);
        cartQuery.setParameter("cart_id", cart_id);
        cartQuery.setParameter("product_id", product_id);
        System.out.println(cart_id);
        System.out.println(product_id);
        return cartQuery.getSingleResult();
    }

    public Cart update(Cart cart) {
        Session session = sessionFactory.getCurrentSession();
        session.saveOrUpdate(cart);
        return cart;
    }

    public boolean delete(Long id) {
        Session session = sessionFactory.getCurrentSession();
        Cart cart = get(id);
        if (cart != null) {
            session.delete(cart);
            return true;
        } else return false;
    }
//    public List<Cart> getByCustomerId(Long id) {
//        Session session = sessionFactory.getCurrentSession();
//        Query<Cart> cartQuery = session.createQuery("from Cart where customer_id = :id", Cart.class);
//        cartQuery.setParameter("id", id);
//        return cartQuery.getResultList();
//    }
}

