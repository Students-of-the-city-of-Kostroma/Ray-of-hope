package com.example.splashapp;

import javax.validation.constraints.NotNull;

public abstract class M_User  {
    private String email, description,
            tel=" ";
    String picture;
    private String id;

    public M_User(@NotNull String id, @NotNull String description,
                  String picture, String tel) {
        this.id=id;
        this.picture = picture;
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

        if (picture !=null)
        return "http://darapana.beget.tech/storage/app/"+ picture;
        else return null;
    }

    public void setImageName(String imageName) { this.picture = imageName; }

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
