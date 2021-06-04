package com.example.splashapp;

import android.content.DialogInterface;
import android.content.Intent;
import android.content.SharedPreferences;
import android.net.Uri;
import android.os.Bundle;
import android.support.design.widget.FloatingActionButton;
import android.support.design.widget.Snackbar;
import android.support.v7.app.AlertDialog;
import android.support.v7.widget.LinearLayoutManager;
import android.support.v7.widget.RecyclerView;
import android.text.method.ScrollingMovementMethod;
import android.text.method.LinkMovementMethod;
import android.view.View;
import android.support.design.widget.NavigationView;
import android.support.v4.view.GravityCompat;
import android.support.v4.widget.DrawerLayout;
import android.support.v7.app.ActionBarDrawerToggle;
import android.support.v7.app.AppCompatActivity;
import android.support.v7.widget.Toolbar;
import android.view.Menu;
import android.view.MenuItem;
import android.widget.ImageView;
import android.widget.TextView;

import com.squareup.picasso.Picasso;

import org.json.JSONObject;

import java.util.ArrayList;
import java.util.concurrent.ExecutionException;
import java.util.concurrent.TimeUnit;

public class ViewOrg extends AppCompatActivity {

    SharedPreferences sPref;
    final String sv_id = "";
    String orgId;
    boolean fav;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.content_view_org);
        Toolbar toolbar = (Toolbar) findViewById(R.id.toolbar);
        setSupportActionBar(toolbar);

        orgId=ListOfOrg.testId;

        C_Organization.current=new Network().AnotherOrg(orgId);


            TextView textview= (TextView) findViewById(R.id.textView25);
            textview.setText(C_Organization.current.getName());

            textview= (TextView) findViewById(R.id.textView22);
            textview.setText(C_Organization.current.getAbout());

            textview= (TextView) findViewById(R.id.textView20);
            textview.setText(C_Organization.current.getAdress()+"\n"+C_Organization.current.getNumber());

            textview= (TextView) findViewById(R.id.textView24);
            textview.setText(C_Organization.current.getCity());

            textview= (TextView) findViewById(R.id.textView16);
            textview.setText(C_Organization.current.getTypeActivity());
            fav=inFav(orgId);

            if (fav)
            {((ImageView) findViewById(R.id.imgfav)).setImageResource(android.R.drawable.star_big_on);}
            else { ((ImageView) findViewById(R.id.imgfav)).setImageResource(android.R.drawable.star_big_off);}

            ImageView imageView = (ImageView) findViewById(R.id.imageView12);
        try {
            imageView.setImageBitmap(C_Citizen.Iam.getImageHash());
            //Picasso.get().load(C_Organization.current.getImageName()).into(imageView);
        }
        catch (Exception e)
        {
            Picasso.get().load(R.mipmap.about_logo).into(imageView);
        }


        TextView textview3= (TextView) findViewById(R.id.textView24);
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

    @Override
    public void onBackPressed() {
        Intent intent = new Intent(this, ListOfOrg.class);
        startActivity(intent);
        finish();
    }


    public boolean inFav(String id)
    {
        if (C_Organization.FavOrg==null)
            return false;
        for (int i=0; i<C_Organization.FavOrg.size();i++)
        {
            if (C_Organization.FavOrg.get(i).getId().equals(id))
                return true;
        }
        return false;
    }

    public void FavClick(View view) {
        String [] param=new String[4];
        param[0]=C_Citizen.Iam.getId();
        param[1]=orgId;
        fav=!fav;
        if (fav) {
            ((ImageView) findViewById(R.id.imgfav)).setImageResource(android.R.drawable.star_big_on);
            param[2]="id_citizen";
            param[3]="id_organization";
            new Network().SaveDelFavOrg(param,fav);
        } else {
            ((ImageView) findViewById(R.id.imgfav)).setImageResource(android.R.drawable.star_big_off);
            param[2]="id_cit";
            param[3]="id_org";
            new Network().SaveDelFavOrg(param,fav);
        }
    }


    void loadId() {
        sPref = getPreferences(MODE_PRIVATE);
        String savedText = sPref.getString(sv_id, "");
        ListOfOrg.testId=savedText;
    }

    void saveId() {
        sPref = getPreferences(MODE_PRIVATE);
        SharedPreferences.Editor ed = sPref.edit();
        ed.putString(sv_id, ListOfOrg.testId);
        ed.commit();
    }
    @Override
    protected void onDestroy() {
        super.onDestroy();
        saveId();
    }

    public void Activisms (View view)
    {
        Intent intent = new Intent(this, OrgPostLentaActivity.class);
        startActivity(intent);
        //finish();
    }

    public  void ToMyProf(View view)
    {
        boolean cit=Choice.citezen;
        if (cit) {
            Intent intent = new Intent(this, CitProf.class);
            startActivity(intent);
        }
        else { Intent intent = new Intent(this, MyOrgProf.class);
            startActivity(intent);}

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
    public  void ToChat(View view)
    {
        Intent intent = new Intent(this, ThisChat.class);
        startActivity(intent);
    }
    public void ToLenta(View view)
    {
        Intent intent = new Intent(this, LentaActivity.class);
        startActivity(intent);
        finish();
    }
    public void ToChats(View view)
    {
        Intent intent = new Intent(this, ListOfChats.class);
        startActivity(intent);
        finish();
    }
}
