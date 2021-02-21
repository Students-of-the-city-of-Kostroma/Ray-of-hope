package com.example.splashapp;
import android.media.Image;

import javax.validation.constraints.NotNull;

public abstract class M_User  {
    private String email, description,
            tel=" ";
    String image;
    private String id;

    public M_User(@NotNull String id, @NotNull String description,
                  String image, String tel) {
        this.id=id;
        this.image = image;
        this.description = description.replaceAll("null", " ");
        this.tel = tel.replaceAll("null", " ");
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
        return description;
    }

    public void setAbout(@NotNull String about) {
        this.description = about;
    }

    public String getImageName() {
        return image;
    }

    public void setImageName(String imageName) { this.image = imageName; }

    public String getNumber() {
        return tel;
    }

    public void setNumber(String number) {
        this.tel = number;
    }

    public boolean ValidationEmail(String email)
    {
        return true;
    }

    public boolean ValidationPassword(String password)
    {
        return true;
    }
}
