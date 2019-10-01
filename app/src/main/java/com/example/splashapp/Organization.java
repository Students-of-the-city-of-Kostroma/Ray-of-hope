package com.example.splashapp;

import android.media.Image;

import javax.validation.constraints.NotNull;
import java.util.List;

public class Organization extends User {
    private String name,city, adress, typeactivity;
    private List<String> documentsL, documentsP;

    public Organization(@NotNull String id, String city, String about,
                         String number,
                        @NotNull String name, String avatar, String adress,String typeactivity,List<String> documentsL,List<String> documentsP) {
        super(id, about, avatar, number);
        this.name = name;
        this.city = city;
        this.adress = adress.replaceAll("null", "");;
        this.typeactivity = typeactivity;
        this.documentsL = documentsL;
        this.documentsP = documentsP;
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

    public void setAdress(@NotNull String adress) {
        this.adress = adress;
    }

    public String getAdress() {
        return adress;
    }

    public void setTypeActivity(@NotNull String typeactivity) {
        this.typeactivity = typeactivity;
    }

    public String getTypeActivity() {
        return typeactivity;
    }

    public void setName(@NotNull String city) {
        this.city = city;
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
