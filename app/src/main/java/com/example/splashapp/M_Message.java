package com.example.splashapp;

import java.util.Date;

public class M_Message {

    String text;
    int id;
    Date time;
    boolean me;

    M_Message(int id, String text, Date time, boolean me)
    {
        this.id=id;
        this.text=text;
        this.time=time;
        this.me=me;
    }

    public int getId()
    {
        return id;
    }
    public String getText()
    {
        return text;
    }
    public Date getTime()
    {
        return time;
    }
    public boolean getMe(){return me;}
}
