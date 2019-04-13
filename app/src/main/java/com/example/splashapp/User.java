package com.example.splashapp;
import javax.validation.constraints.NotNull;

public abstract class User extends Identified {
    private String email, about,
            number, imageName;

    public User(@NotNull int id, @NotNull String email, @NotNull String about,
                String imageName, String number) {
        super(id);
        this.email = email;
        this.imageName = imageName;
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

    public String getImageName() {
        return imageName;
    }

    public void setImageName(String imageName) {
        this.imageName = imageName;
    }

    public String getNumber() {
        return number;
    }

    public void setNumber(String number) {
        this.number = number;
    }
}
