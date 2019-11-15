package com.example.splashapp;

import javax.validation.constraints.NotNull;
import java.util.Date;
import java.util.List;

public class M_Event extends M_Activism {
    private List<M_User> willGo;

    public M_Event(@NotNull String id, @NotNull String name, @NotNull String description, @NotNull Date postDate,
                   @NotNull Date date,
                   List<M_User> willGo) {
        super(id, name, description, postDate, date);
        this.willGo = willGo;
    }

    public List<M_User> getWillGo() {
        return willGo;
    }

    public void setWillGo(@NotNull List<M_User> willGo) {
        this.willGo = willGo;
    }
}