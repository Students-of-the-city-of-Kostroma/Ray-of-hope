package com.example.splashapp;

import javax.validation.constraints.NotNull;

import java.util.ArrayList;
import java.util.List;

public class M_Organization extends M_User {
    private String name,location, adress, type_active;
    private List<String> documentsL=new ArrayList<String>(), documentsP=new ArrayList<String>();
    public List<M_Activism> posts=new ArrayList<M_Activism>();

    public M_Organization(@NotNull String id, String location, String about,
                          String number,
                          @NotNull String name, String avatar, String adress, String typeactivity, List<String> documentsL, List<String> documentsP) {
        super(id, about, avatar, number);
        this.name = name;
        this.location = location;
        this.adress = adress.replaceAll("null", "");;
        this.type_active = typeactivity;
        this.documentsP = documentsP;
        this.documentsL = documentsL;
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

    public List<String> getDocumentsL() { return documentsL; }

    public void setDocumentsL(@NotNull List<String> documentsL) { this.documentsL = documentsL; }

    public List<String> getDocumentsP() {
        return documentsP;
    }

    public void setDocumentsP(@NotNull List<String> documentsP) {
        this.documentsP = documentsP;
    }
}
