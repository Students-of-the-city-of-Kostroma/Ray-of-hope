package com.example.splashapp;

import android.content.DialogInterface;
import android.content.Intent;
import android.content.SharedPreferences;
import android.net.Uri;
import android.os.Bundle;
import android.support.v7.app.AlertDialog;
import android.support.v7.widget.LinearLayoutManager;
import android.support.v7.widget.RecyclerView;
import android.text.method.ScrollingMovementMethod;
import android.text.method.LinkMovementMethod;
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

public class ViewOrg extends AppCompatActivity
        implements GalleryAdapter.ItemClickListener  {

    private GalleryAdapter adapter;
    public static M_Organization Org;
    SharedPreferences sPref;
    final String sv_id = "";

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.content_view_org);
        Toolbar toolbar = (Toolbar) findViewById(R.id.toolbar);
        setSupportActionBar(toolbar);

        String orgId=ListOfOrg.testId;


        CallDB_ProfOrg RO=new CallDB_ProfOrg();
        if (orgId==null) {
            loadId();
            orgId=ListOfOrg.testId;
        }
        else saveId();


        RO.execute(orgId);
        String Ret = "";
        try {
            Ret = RO.get(5, TimeUnit.SECONDS);

            Org=C_Organization.decodeJSON(Ret,orgId);

            TextView textview= (TextView) findViewById(R.id.textView25);
            textview.setText(Org.getName());

            textview= (TextView) findViewById(R.id.textView22);
            textview.setText(Org.getAbout());

            textview= (TextView) findViewById(R.id.textView20);
            textview.setText(Org.getAdress()+"\n"+Org.getNumber());

            textview= (TextView) findViewById(R.id.textView24);
            textview.setText(Org.getCity());

            textview= (TextView) findViewById(R.id.textView16);
            textview.setText(Org.getTypeActivity());

            ImageView imageView = (ImageView) findViewById(R.id.imageView12);
            Picasso.get().load(Org.getImageName()).into(imageView);


            RecyclerView recyclerView = findViewById(R.id.frameLayout);
            LinearLayoutManager horizontalLayoutManager
                    = new LinearLayoutManager(this, LinearLayoutManager.HORIZONTAL, false);
            recyclerView.setLayoutManager(horizontalLayoutManager);
            adapter = new GalleryAdapter(this, Org.getDocumentsP(), Org.getDocumentsL());
            adapter.setClickListener(this);
            recyclerView.setAdapter(adapter);

        } catch (InterruptedException e) {
            e.printStackTrace();
        } catch (ExecutionException e) {
            e.printStackTrace();
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



    @Override
    public void onItemClick(View view, int position) {
        try{
        String url=adapter.getLink(position);
        Intent browserIntent = new
                Intent(Intent.ACTION_VIEW, Uri.parse(url));
        this.startActivity(browserIntent);
        }catch (Exception e) {
            e.printStackTrace();
        }
    }
    @Override
    public void onBackPressed() {
        DrawerLayout drawer = (DrawerLayout) findViewById(R.id.drawer_layout);
        if (drawer.isDrawerOpen(GravityCompat.START)) {
            drawer.closeDrawer(GravityCompat.START);
        } else {
            super.onBackPressed();
        }
    }

    public void Activisms (View view)
    {
        Intent intent = new Intent(this, ActivView.class);
        startActivity(intent);
        finish();
    }
    public void Need (View view)
    {
        Intent intent = new Intent(this, NeedView.class);
        startActivity(intent);
        finish();
    }
    public void Event (View view)
    {
        Intent intent = new Intent(this, EventView.class);
        startActivity(intent);
        finish();
    }
    boolean ch=false;
    public  void Close()
    {
        AlertDialog.Builder buil = new AlertDialog.Builder(ViewOrg.this);
        buil.setMessage("Вы действительно хотите выйти из аккаунта?");
        buil.setCancelable(false);
        buil.setPositiveButton("Да", new DialogInterface.OnClickListener() {
                    @Override
                    public void onClick(DialogInterface dialog, int which) {

                        ch=true;
                        ToChoice(ch);
                        dialog.cancel();
                    }
                }
        );
        buil.setNegativeButton("Нет", new DialogInterface.OnClickListener() {
            @Override
            public void onClick(DialogInterface dialog, int which) {
                dialog.cancel();
            }
        });
        AlertDialog al=buil.create();
        al.show();
    }
    public  void ToChoice(boolean b)
    {
        if (b){
            Intent intent = new Intent(this, Choice.class);
            startActivity(intent);
            finish();}
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
}
