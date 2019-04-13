package com.example.splashapp;

import javax.validation.constraints.NotNull;

public class UserCredential {
    private String email, password;

    public UserCredential(@NotNull String email, @NotNull String password) {
        this.email = email;
        this.password = password;
    }

    public String getEmail() {
        return email;
    }

    public String getPassword() {
        return password;
    }

    public class CredentialResponse {
        private String key;
        private User user;

        public CredentialResponse(@NotNull String key, @NotNull User user) {
            this.key = key;
            this.user = user;
        }

        public String getKey() {
            return key;
        }

        public User getUser() {
            return user;
        }
    }
}