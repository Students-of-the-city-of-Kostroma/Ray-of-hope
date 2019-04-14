package com.example.splashapp;


import javax.validation.constraints.NotNull;

public abstract class Identified {
    private int id;

    public Identified(@NotNull int id) {
        this.id = id;
    }

    public int getId() {
        return id;
    }

    public void setId(@NotNull int id) {
        this.id = id;
    }
}
