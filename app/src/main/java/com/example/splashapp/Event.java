package com.example.splashapp;

import javax.validation.constraints.NotNull;
import java.util.Date;
import java.util.List;

public class Event extends Activism {
    private List<User> willGo;

    public Event(@NotNull String id, @NotNull String name, @NotNull String description, @NotNull Date postDate,
                 @NotNull Date date,
                 List<User> willGo) {
        super(id, name, description, postDate, date);
        this.willGo = willGo;
    }

    public List<User> getWillGo() {
        return willGo;
    }

    public void setWillGo(@NotNull List<User> willGo) {
        this.willGo = willGo;
    }
}