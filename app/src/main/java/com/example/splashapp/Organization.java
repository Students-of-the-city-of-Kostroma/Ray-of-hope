package com.example.splashapp;

import android.media.Image;

import javax.validation.constraints.NotNull;
import java.util.List;

public class Organization extends User {
    private String name,city;
    private List<String> documents;

    public Organization(@NotNull String id, String city, String about,
                         String number,
                        @NotNull String name, List<String> documents,String avatar) {
        super(id, about, avatar, number);
        this.name = name;
        this.city = city;
        this.documents = documents;
    }

    public String getName() {
        return name;
    }

    public void setCity(@NotNull String city) {
        this.city = city;
    }

    public String getCity() {
        return city;
    }

    public void setName(@NotNull String city) {
        this.city = city;
    }

    public List<String> getDocuments() {
        return documents;
    }

    public void setDocuments(@NotNull List<String> documents) {
        this.documents = documents;
    }
}
