package com.example.splashapp;
import android.media.Image;

import javax.validation.constraints.NotNull;

public abstract class M_User  {
    private String email, about,
            number;
    String image;
    private String id;

    public M_User(@NotNull String id, @NotNull String about,
                  String image, String number) {
        this.id=id;
        this.image = image;
        this.about = about.replaceAll("null", " ");
        this.number = number.replaceAll("null", " ");
    }

    public String getId() {
        return id;
    }

    public void setId(@NotNull String id) {
        this.id = id;
    }

    public String getEmail() {
        return email;
    }

    public void setEmail(@NotNull String email) {
        this.email = email;
    }

    public String getAbout() {
        return about;
    }

    public void setAbout(@NotNull String about) {
        this.about = about;
    }

    public String getImageName() {
        return image;
    }

    public void setImageName(String imageName) { this.image = imageName; }

    public String getNumber() {
        return number;
    }

    public void setNumber(String number) {
        this.number = number;
    }
}
