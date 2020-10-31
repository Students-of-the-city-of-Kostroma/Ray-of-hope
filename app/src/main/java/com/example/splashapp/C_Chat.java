package com.example.splashapp;

import java.util.ArrayList;
import java.util.Date;
import java.util.List;

public class C_Chat {

    static public List<M_Chat> ListChat=new ArrayList<M_Chat>();
    static M_Chat m_chat=new M_Chat("0",C_Organization.morg);
    static int TestId=0;
    static M_Message m_message=new M_Message(0,"qwertyuiopasdfghjklzxcvbnm",new Date(),false);
    static M_Message m_message1=new M_Message(1,"qwertyuiopasdfghjklzxcvbnm",new Date(),true);
    static public void C_Ch()
    {
        m_chat.ListMessage.add(m_message);
        m_chat.ListMessage.add(m_message1);
        m_chat.ListMessage.add(m_message);
        m_chat.ListMessage.add(m_message1);
        m_chat.ListMessage.add(m_message);
        m_chat.ListMessage.add(m_message1);
        m_chat.ListMessage.add(m_message);
        m_chat.ListMessage.add(m_message);
        ListChat.add(m_chat);

        ListChat.add(new M_Chat("1",C_Organization.morg1));
    }

}
