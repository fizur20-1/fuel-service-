package com.controller;

import com.domain.Authority;
import com.domain.User;
import com.service.RegistrationService;
import org.springframework.http.ResponseEntity;
import org.springframework.security.access.prepost.PreAuthorize;
import org.springframework.web.bind.annotation.*;

import javax.validation.Valid;
import java.security.Principal;
import java.util.ArrayList;
import java.util.List;

@CrossOrigin()
@RestController
@RequestMapping("/register")
public class RegistrationController {

    private RegistrationService registrationService;

    public RegistrationController(RegistrationService registrationService) {
        this.registrationService = registrationService;
    }

    @PostMapping("/customer")
    public boolean registerCustomer(@Valid @RequestBody User user) {
        Authority authority = new Authority();
        authority.setId(2L);
        List<Authority> authorities = new ArrayList<>();
        authorities.add(authority);
        user.setAuthorities(authorities);
        registrationService.insert(user);
        return true;
    }
    @PostMapping("/delivery")
    public boolean registerDelivery(@Valid @RequestBody User user) {
        Authority authority = new Authority();
        authority.setId(3L);
        List<Authority> authorities = new ArrayList<>();
        authorities.add(authority);
        user.setAuthorities(authorities);
        registrationService.insert(user);
        return true;
    }
//    @PostMapping("/admin")
//    public boolean registerAdmin(@Valid @RequestBody User user) {
//        registrationService.insert(user);
//        return true;
//    }

    @GetMapping("/login-delivery")
    @PreAuthorize("hasRole('ROLE_DELIVERY')")
    public ResponseEntity<String> loginDelivery(Principal principal) {
        return ResponseEntity.ok(principal.getName());
    }

    @GetMapping("/login-customer")
    @PreAuthorize("hasRole('ROLE_CUSTOMER')")
    public ResponseEntity<String> loginCustomer(Principal principal) {
        return ResponseEntity.ok(principal.getName());
    }

    @GetMapping("/login-admin")
    @PreAuthorize("hasRole('ROLE_ADMIN')")
    public ResponseEntity<Object> loginAdmin(Principal principal) {
        //SecurityContextHolder.getContext().getAuthentication().getPrincipal();
        return ResponseEntity.ok(principal.getName());
    }

    @RequestMapping("/test")
    public String testing() {
        return "hi";
    }
}