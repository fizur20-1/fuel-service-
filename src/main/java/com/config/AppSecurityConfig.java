package com.config;

import org.springframework.context.annotation.Bean;
import org.springframework.context.annotation.Configuration;
import org.springframework.security.config.annotation.method.configuration.EnableGlobalMethodSecurity;
import org.springframework.security.config.annotation.web.builders.HttpSecurity;
import org.springframework.security.config.annotation.web.configuration.EnableWebSecurity;
import org.springframework.security.crypto.bcrypt.BCryptPasswordEncoder;
import org.springframework.security.crypto.password.PasswordEncoder;
import org.springframework.security.web.SecurityFilterChain;
import org.springframework.security.web.csrf.CookieCsrfTokenRepository;
import org.springframework.web.cors.CorsConfiguration;
import org.springframework.web.cors.CorsConfigurationSource;
import org.springframework.web.cors.UrlBasedCorsConfigurationSource;

import java.util.Arrays;

@Configuration
@EnableWebSecurity
@EnableGlobalMethodSecurity(prePostEnabled = true)
public class AppSecurityConfig {

    @Bean
    public PasswordEncoder encoder() {
        return new BCryptPasswordEncoder();
    }

//    @Bean
//    CorsConfigurationSource corsConfigurationSource() {
//        CorsConfiguration configuration = new CorsConfiguration();
//        configuration.setAllowedOrigins(Arrays.asList("http://localhost"));
//        configuration.setAllowedMethods(Arrays.asList("GET", "POST", "PUT", "DELETE"));
//        configuration.setAllowedHeaders(Arrays.asList("Authorization", "Origin", "X-Requested-With", "Content-Type", "Accept"));
//        UrlBasedCorsConfigurationSource source = new UrlBasedCorsConfigurationSource();
//        source.registerCorsConfiguration("/**", configuration);
//        return source;
//    }

    @Bean
    public SecurityFilterChain filterChain(HttpSecurity http) throws Exception {
        http
                //.csrf(csrf -> csrf.csrfTokenRepository(CookieCsrfTokenRepository.withHttpOnlyFalse()))
                //.cors()
                .csrf().disable()
                .cors().disable()
                //.and()
                .httpBasic()
                .and()

                .authorizeRequests()
                // login api is... any user to auth
                .antMatchers("/register/**").permitAll()//.access("hasAnyRole('ROLE_USER', 'ROLE_ADMIN')")
                // tax api restricted to... USER
                //.antMatchers("/tax/**").access("hasRole('ROLE_USER')")
                // Authority api restricted to... ADMIN
                //.antMatchers("/api/**").access("hasRole('ROLE_ADMIN')")
                // Admin api restricted to... ADMIN
                .antMatchers("/admin/**").access("hasRole('ROLE_ADMIN')")
                .antMatchers("/customer/**").access("hasRole('ROLE_CUSTOMER')")
                .antMatchers("/delivery/**").access("hasRole('ROLE_DELIVERY')")
                .anyRequest().authenticated();
        //.and()
        //.formLogin()
        //.loginPage("/login/success")
        //.defaultSuccessUrl("/public/login-success");
        // Login api restricted to... ADMIN or USER
        //.antMatchers("/login/**").access("hasRole('ROLE_ADMIN') or hasRole('ROLE_USER')")
        //.and()
        //.rememberMe();

        //.formLogin()
        //.loginPage("/login")
        //.and()
        //.logout();
        return http.build();
    }
}
