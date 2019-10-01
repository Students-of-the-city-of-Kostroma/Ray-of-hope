package com.example.splashapp;


import javax.validation.constraints.NotNull;

public abstract class Identified {
    private String id;

    public Identified(@NotNull String id) {
        this.id = id;
    }

    public String getId() {
        return id;
    }

    public void setId(@NotNull String id) {
        this.id = id;
    }
}
