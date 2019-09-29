package com.example.splashapp;

import android.media.Image;

import javax.validation.constraints.NotNull;

public class Citizen extends User {

    private String firstName, lastName, city;

    public Citizen(@NotNull String id, @NotNull String email, @NotNull String about,
                   Image image, String number,
                   @NotNull String firstName, @NotNull String lastName,
                   String city) {
        super(id, email, about, image, number);
        this.firstName = firstName;
        this.lastName = lastName;
        this.city = city;
    }

    public String getFirstName() {
        return firstName;
    }

    public void setFirstName(@NotNull String firstName) {
        this.firstName = firstName;
    }

    public String getLastName() {
        return lastName;
    }

    public void setLastName(@NotNull String lastName) {
        this.lastName = lastName;
    }

    public String getCity() {
        return city;
    }

    public void setCity(String city) {
        this.city = city;
    }
}