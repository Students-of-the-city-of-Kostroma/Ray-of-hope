package com.example.splashapp;

import java.util.ArrayList;
import java.util.Date;
import java.util.List;

public class M_Chat {

    List<M_Message> ListMessage=new ArrayList<M_Message>();
    M_User withWho;
    String id;

   public M_Chat (String id, M_User withWho)
    {
        this.id=id;
        this.withWho=withWho;
    }
    public M_Chat ()
    {
    }
    public String getWithWho()
    {
        return withWho.getEmail();
    }

    public String getLastMessage()
    {
        String s=(ListMessage.get(ListMessage.size()-1)).getText();
        return s;
    }
    public void CreateMessage(String text, boolean m)
    {
        Date d=new Date();
        int id=0;
        try {
            id=(ListMessage.get(ListMessage.size()-1)).getId();
            id++;
        }
        catch (Exception e)
        {}
        ListMessage.add(new M_Message(id,text,d,m));
    }
    public String getId()
    {
        return id;
    }

}
