package com.example.splashapp;

import org.json.JSONObject;

import java.util.ArrayList;
import java.util.List;

public class C_Organization extends ControllerUser {


    static List<M_Organization> ListOrganization=new ArrayList<M_Organization>();
    static List<String> s=new ArrayList<String>();
    static M_Organization morg=new M_Organization("0","Кострома","блаблабла", "0987654321","Название","","ул. Такая-то", "Животные", s,s);
    static M_Organization morg1=new M_Organization("1","Кострома","блаблаблаблаблаблаблаблабла", "0987654321","Название2","","ул. Такая-то", "Животные", s,s);

    public C_Organization(){

    }
    static public void C_Org(){
        ListOrganization.add(morg);
        ListOrganization.add(morg1);
    }

    @Override
    public M_User Update(M_User Organization) {
        return null;
    }
    @Override
    public  M_Organization Autorization(M_User Organization){ return null; }

    @Override
    public  M_Organization Registration(M_User Organization){ return null; }

    @Override
    public  M_User getDateProfile (){ return null; }

    public void  RefreshList(List<M_Organization> ListChat) {}

    public static M_Organization decodeJSON(String Ret, String id)
    {
        try {
            JSONObject json = new JSONObject(Ret);
            String name = json.get("name").toString();
            String avatar = json.get("avatar").toString();
            String city = json.get("region_name").toString()+" "  + json.get("city_name").toString();
            String activity = json.get("type_of_activity_name").toString();
            String description = json.get("description").toString();
            String contacts = "Телефон: " + json.get("number_phone").toString();
            String adress = "Адрес: " + json.get("address").toString();

            String docslink1 = json.get("docs_links").toString();
            docslink1 = docslink1.substring(1);
            docslink1 = docslink1.substring(0, docslink1.length() - 1);
            String[] docslink = docslink1.split(",", -1);

            String docsprev1 = json.get("docs_preview").toString();
            docsprev1 = docsprev1.substring(1);
            docsprev1 = docsprev1.substring(0, docsprev1.length() - 1);
            String[] docsprev = docsprev1.split(",", -1);

            ArrayList<String> dcprev = new ArrayList<>();
            ArrayList<String> dclink = new ArrayList<>();
            try {
                for (int i = 0; i < docslink.length; i++) {
                    docslink[i] = docslink[i].substring(1);
                    docslink[i] = docslink[i].substring(0, docslink[i].length() - 1);
                    dclink.add("http://"+docslink[i]);
                    docsprev[i] = docsprev[i].substring(1);
                    docsprev[i] = docsprev[i].substring(0, docsprev[i].length() - 1);
                    dcprev.add("http://"+docsprev[i]);
                }
            }catch (Exception e) {
                e.printStackTrace();
            }

            return new M_Organization(id, city, description, contacts, name, avatar, adress, activity ,dclink, dcprev);
        }catch (Exception e) {
            e.printStackTrace();
            return null;
        }

    }
}
