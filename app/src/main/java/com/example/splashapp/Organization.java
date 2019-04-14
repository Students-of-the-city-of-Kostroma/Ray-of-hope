package com.example.splashapp;

import javax.validation.constraints.NotNull;
import java.util.List;

public class Organization extends User {
    private String name;
    private List<String> documents;

    public Organization(@NotNull int id, @NotNull String email, @NotNull String about,
                        String imageName, String number,
                        @NotNull String name, @NotNull List<String> documents) {
        super(id, email, about, imageName, number);
        this.name = name;
        this.documents = documents;
    }

    public String getName() {
        return name;
    }

    public void setName(@NotNull String name) {
        this.name = name;
    }

    public List<String> getDocuments() {
        return documents;
    }

    public void setDocuments(@NotNull List<String> documents) {
        this.documents = documents;
    }
}
