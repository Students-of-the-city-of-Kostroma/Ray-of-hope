package com.example.splashapp;
import android.media.Image;

import javax.validation.constraints.NotNull;

public abstract class User extends Identified {
    private String email, about,
            number;
    Image image;

    public User(@NotNull String id, String email, @NotNull String about,
                Image image, String number) {
        super(id);
        this.email = email;
        this.image = image;
        this.about = about;
        this.number = number;
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

    public Image getImageName() {
        return image;
    }

    public void setImageName(Image imageName) {
        this.image = imageName;
    }

    public String getNumber() {
        return number;
    }

    public void setNumber(String number) {
        this.number = number;
    }
}
