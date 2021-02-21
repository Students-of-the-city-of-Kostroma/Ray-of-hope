package com.example.splashapp;

import javax.validation.constraints.NotNull;

public class M_Citizen extends M_User {

    private String name, f_name, o_name, city=" ";

    public M_Citizen(@NotNull String id, @NotNull String email, @NotNull String about,
                     String image, String number,
                     @NotNull String firstName, @NotNull String lastName, String o_name,
                     String city) {
        super(id, about, image, number);
        this.name = firstName;
        this.f_name = lastName;
        this.o_name = o_name;
        this.city = city;
    }

    public String getFirstName() {
        return name;
    }

    public void setFirstName(@NotNull String firstName) {
        this.name = firstName;
    }

    public String getLastName() {
        return f_name;
    }

    public void setLastName(@NotNull String lastName) {
        this.f_name = lastName;
    }

    public String getOName() {
        return o_name;
    }

    public void setOtName(@NotNull String o_name) {
        this.o_name = o_name;
    }

    public String getCity() {
        return city;
    }

    public void setCity(String city) {
        this.city = city;
    }
}