package com.controller;

import com.domain.Cart;
import com.domain.Orders;
import com.exception.NotFoundAlertException;
import com.service.CustomerService;
import com.service.DeliveryService;
import org.springframework.beans.propertyeditors.StringTrimmerEditor;
import org.springframework.http.ResponseEntity;
import org.springframework.web.bind.WebDataBinder;
import org.springframework.web.bind.annotation.*;

import java.security.Principal;
import java.util.List;
import java.util.Optional;

@CrossOrigin()
@RestController
@RequestMapping("/delivery")
public class DeliveryController {
    private DeliveryService deliveryService;

    public DeliveryController(DeliveryService deliveryService) {
        this.deliveryService = deliveryService;
    }

    @InitBinder
    public void initBinder(WebDataBinder webDataBinder) {
        StringTrimmerEditor stringTrimmerEditor = new StringTrimmerEditor(true);
        webDataBinder.registerCustomEditor(String.class, stringTrimmerEditor);
    }

    @GetMapping("/pending-orders")
    public ResponseEntity<List<Orders>> getPendingOrders() {
        return ResponseEntity.ok().body(deliveryService.getOrdersByStatus("PENDING"));
    }

//    @GetMapping("/my-delivery")
//    public ResponseEntity<List<Orders>> getMyDeliveryByStatus(Principal principal) {
//        return ResponseEntity.ok().body(deliveryService.getMyDeliveryByStatus(principal,"PENDING"));
//    }

    @GetMapping("/get-cart/{cart_id}")
    public ResponseEntity<List<Cart>> getCart(@PathVariable String cart_id) {
        Optional<List<Cart>> cart = Optional.ofNullable(deliveryService.getAllByCartId(cart_id));
        if (cart.isPresent()) {
            return ResponseEntity.ok().body(cart.get());
        }
        throw new NotFoundAlertException("Record not found [" + cart_id + "]");
    }

    @GetMapping("/customer-info/{customer_id}")
    public ResponseEntity<Object> getCustomerInfo(@PathVariable Long customer_id) {
        Optional<Object> cart = Optional.ofNullable(deliveryService.getCustomerInfo(customer_id));
        if (cart.isPresent()) {
            return ResponseEntity.ok().body(cart.get());
        }
        throw new NotFoundAlertException("Record not found [" + customer_id + "]");
    }

    @GetMapping("/accept-delivery/{delivery_id}")
    public ResponseEntity<String> acceptDelivery(@PathVariable Long delivery_id) {
        Orders order = deliveryService.acceptDeliveryById(delivery_id);
        if (order.getId() == null) {
            return ResponseEntity.ok().body("Failed to update delivery status to DELIVERING");
        }
        return ResponseEntity.ok().body("Delivery status updated to DELIVERING");
    }
}
