package com.example.splashapp;

import android.content.DialogInterface;
import android.content.Intent;
import android.content.SharedPreferences;
import android.net.Uri;
import android.os.Bundle;
import android.support.v7.app.AlertDialog;
import android.support.v7.widget.LinearLayoutManager;
import android.support.v7.widget.RecyclerView;
import android.text.method.LinkMovementMethod;
import android.text.method.ScrollingMovementMethod;
import android.view.View;
import android.support.design.widget.NavigationView;
import android.support.v4.view.GravityCompat;
import android.support.v4.widget.DrawerLayout;
import android.support.v7.app.AppCompatActivity;
import android.support.v7.widget.Toolbar;
import android.widget.ImageView;
import android.widget.TextView;

import com.squareup.picasso.Picasso;

import org.json.JSONObject;

import java.util.ArrayList;
import java.util.concurrent.ExecutionException;
import java.util.concurrent.TimeUnit;

public class MyOrgProf extends AppCompatActivity
      {


    SharedPreferences sPref;
    final String sv_id = "";

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.content_my_org_prof);
        Toolbar toolbar = (Toolbar) findViewById(R.id.toolbar);
        setSupportActionBar(toolbar);
        C_Organization.MyOrg=new Network().LсOrg(C_Organization.MyOrg.getId());
        String moID=LoginOrgActivity.MyOrgId;


        if (moID==null) {
            loadId();
            moID=LoginOrgActivity.MyOrgId;
        }
        else saveId();

        try {

            TextView textview= (TextView) findViewById(R.id.textView25);
            textview.setText(C_Organization.MyOrg.getName());

            textview= (TextView) findViewById(R.id.textView22);
            textview.setText(C_Organization.MyOrg.getAbout());

            textview= (TextView) findViewById(R.id.textView20);
            textview.setText(C_Organization.MyOrg.getAdress()+"\n"+C_Organization.MyOrg.getNumber());

            textview= (TextView) findViewById(R.id.textView24);
            textview.setText(C_Organization.MyOrg.getCity());

            textview= (TextView) findViewById(R.id.textView16);
            textview.setText(C_Organization.MyOrg.getTypeActivity());

            ImageView imageView = (ImageView) findViewById(R.id.imageView12);
            try {
                imageView.setImageBitmap(C_Citizen.Iam.getImageHash());
                //Picasso.get().load(C_Organization.MyOrg.getImageName()).into(imageView);
            }
            catch (Exception e)
            {
                Picasso.get().load(R.mipmap.about_logo).into(imageView);
            }


        } catch (Exception e) {
            e.printStackTrace();
        }

        TextView textview= (TextView) findViewById(R.id.textView24);
        textview.setSelected(true);

        TextView textview0= (TextView) findViewById(R.id.textView25);
        textview0.setSelected(true);

        TextView textview1= (TextView) findViewById(R.id.textView22);
        textview1.setMovementMethod(new ScrollingMovementMethod());

        TextView textview2= (TextView) findViewById(R.id.textView20);
        textview2.setMovementMethod(new ScrollingMovementMethod());
        textview2.setMovementMethod(LinkMovementMethod.getInstance());
        NavigationView navigationView = (NavigationView) findViewById(R.id.nav_view);
    }



    void loadId() {
        sPref = getPreferences(MODE_PRIVATE);
        String savedText = sPref.getString(sv_id, "");
        LoginOrgActivity.MyOrgId=savedText;
    }

    void saveId() {
        sPref = getPreferences(MODE_PRIVATE);
        SharedPreferences.Editor ed = sPref.edit();
        ed.putString(sv_id, LoginOrgActivity.MyOrgId);
        ed.commit();
    }
    @Override
    protected void onDestroy() {
        super.onDestroy();
        saveId();
    }

          public void Activisms (View view)
          {
              C_Organization.current=C_Organization.MyOrg;
              Intent intent = new Intent(this, OrgPostLentaActivity.class);
              startActivity(intent);
              //finish();
          }

    public  void toOrgPost(View view)
    {
        Intent intent = new Intent(this, MenuView.class);
        startActivity(intent);
        finish();
    }

    public  void editInfo(View view)
    {
        Intent intent = new Intent(this, OrgEditActivity.class);
        startActivity(intent);
    }

    public  void toNewPost(View view)
    {
        Intent intent = new Intent(this, AddPostActivity.class);
        startActivity(intent);
    }

    public void ToLenta(View view)
    {
        Intent intent = new Intent(this, LentaActivity.class);
        startActivity(intent);
        finish();
    }

    public  void openMenu(View view)
    {
        Intent intent = new Intent(this, MenuView.class);
        startActivity(intent);
        finish();
    }

    public  void ToListOfOrg(View view)
    {
        Intent intent = new Intent(this, ListOfOrg.class);
        startActivity(intent);
        finish();
    }

//    public void Activisms (View view)
//    {
//        Intent intent = new Intent(this, ActivView.class);
//        startActivity(intent);
//        finish();
//    }
//    public void M_Need (View view)
//    {
//        Intent intent = new Intent(this, NeedView.class);
//        startActivity(intent);
//        finish();
//    }
}
