package com.example.splashapp;

import javax.validation.constraints.NotNull;

import java.util.ArrayList;
import java.util.List;

public class M_Organization extends M_User {
    private String name,location, adress, type_active, id_citizen, fav_id;
    public List<M_Post> posts=new ArrayList<M_Post>();

    public M_Organization(@NotNull String id, String location, String about,
                          String number,
                          @NotNull String name, String avatar, String adress, String typeactivity) {
        super(id, about, avatar, number);
        this.name = name;
        this.location = location;
        this.adress = adress.replaceAll("null", "");;
        this.type_active = typeactivity;
    }

    public String getName() {
        return name;
    }

    public void setCity(@NotNull String city) {
        this.location = city;
    }

    public String getCity() {
        return location;
    }

    public void setAdress(@NotNull String adress) {
        this.adress = adress;
    }

    public String getAdress() {
        return adress;
    }

    public void setTypeActivity(@NotNull String typeactivity) {
        this.type_active = typeactivity;
    }

    public String getTypeActivity() {
        return type_active;
    }

    public void setName(@NotNull String location) {
        this.location = location;
    }

    public String getСID() {
        return id_citizen;
    }
    public String getFID() {
        return fav_id;
    }
}
