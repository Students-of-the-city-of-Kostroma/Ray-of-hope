package com.example.splashapp;

import android.annotation.TargetApi;
import android.os.Build;

import java.util.ArrayList;
import java.util.List;
import java.util.concurrent.TimeUnit;

public class C_Activitisms extends ControllerPost{

    List<M_Activism> ListActivism=new ArrayList<M_Activism>();
    public C_Activitisms() { }

    @TargetApi(Build.VERSION_CODES.CUPCAKE)
    @Override
    public boolean Add(M_Post post) {
        try {
            M_Activism _post = (M_Activism)post;
            for (M_Activism element : ListActivism) {
                if (element.getId().equals(_post.getId())) {
                    return false;
                }

            }
            CallDB_VerifyObject flow;
            flow  = new CallDB_VerifyObject();
            String[] data  = {"C_Activitisms", _post.getId(), _post.getName(), _post.getDescription(), _post.getPostDate().toString(),
                    _post.getDate().toString()};
            flow.execute(data);
            String Ret = "";
            try {
                Ret = flow.get(5, TimeUnit.SECONDS);
            } catch (Exception e) { System.out.println(e.getMessage()); }
            ListActivism.add(_post);
        }
        catch (Exception e) { System.out.println(e.getMessage()); }
        return true;
    }

    @TargetApi(Build.VERSION_CODES.CUPCAKE)
    @Override
    public boolean Update(M_Post post) {
        M_Activism _post = (M_Activism)post;
        for (M_Activism element : ListActivism) {
            if (element.getId().equals(_post.getId())) {
                CallDB_VerifyObject flow = new CallDB_VerifyObject();
                String[] data  = {"M_Activism", _post.getId(), _post.getName(), _post.getDescription(),
                        _post.getPostDate().toString(), _post.getDate().toString()};
                flow.execute(data);
                String Ret = "";
                try {
                    Ret = flow.get(5, TimeUnit.SECONDS);
                } catch (Exception e) { System.out.println(e.getMessage()); }
            }
            return true;
        }
        return false;
    }

    @Override
    public boolean Delete(M_Post Activitisms) { return true; }

    @Override
    public  boolean AddComment(M_Post Activitisms, M_Comment comment) { return true; }

    @Override
    public  boolean DeleteComment(M_Post Activitisms, M_Comment comment) { return true; }

    @Override
    public  boolean RefreshList(M_Post Activitisms, M_Comment comment){ return true; }
} 

