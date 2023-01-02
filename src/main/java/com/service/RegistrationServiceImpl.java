package com.service;

import com.domain.User;
import com.repository.UserRepository;
import org.springframework.security.crypto.password.PasswordEncoder;
import org.springframework.stereotype.Service;
import org.springframework.transaction.annotation.Transactional;

@Service
@Transactional
public class RegistrationServiceImpl implements RegistrationService {
    private UserRepository userRepository;
    private PasswordEncoder passwordEncoder;

    public RegistrationServiceImpl(UserRepository userRepository, PasswordEncoder passwordEncoder) {
        this.userRepository = userRepository;
        this.passwordEncoder = passwordEncoder;
    }

    @Transactional
    public User insert(User user) {
        user.setPassword(passwordEncoder.encode(user.getPassword()));
        return userRepository.create(user);
    }
}
