package com.example.splashapp;

import android.content.DialogInterface;
import android.content.Intent;
import android.os.Bundle;
import android.support.design.widget.FloatingActionButton;
import android.support.design.widget.Snackbar;
import android.support.v7.app.AlertDialog;
import android.text.method.LinkMovementMethod;
import android.text.method.ScrollingMovementMethod;
import android.view.View;
import android.support.design.widget.NavigationView;
import android.support.v4.view.GravityCompat;
import android.support.v4.widget.DrawerLayout;
import android.support.v7.app.ActionBarDrawerToggle;
import android.support.v7.app.AppCompatActivity;
import android.support.v7.widget.Toolbar;
import android.view.Menu;
import android.view.MenuItem;
import android.widget.TextView;

public class MyOrgProf extends AppCompatActivity
        implements NavigationView.OnNavigationItemSelectedListener {

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_my_org_prof);
        Toolbar toolbar = (Toolbar) findViewById(R.id.toolbar);
        setSupportActionBar(toolbar);


        DrawerLayout drawer = (DrawerLayout) findViewById(R.id.drawer_layout);
        ActionBarDrawerToggle toggle = new ActionBarDrawerToggle(
                this, drawer, toolbar, R.string.navigation_drawer_open, R.string.navigation_drawer_close);
        drawer.addDrawerListener(toggle);
        toggle.syncState();
        TextView textview= (TextView) findViewById(R.id.textViewAboutOrg1);
        textview.setMovementMethod(new ScrollingMovementMethod());

        TextView textview1= (TextView) findViewById(R.id.textView16);
        textview1.setMovementMethod(new ScrollingMovementMethod());

        TextView textview2= (TextView) findViewById(R.id.textViewAboutOrg);
        textview2.setMovementMethod(new ScrollingMovementMethod());
        textview2.setMovementMethod(LinkMovementMethod.getInstance());
        NavigationView navigationView = (NavigationView) findViewById(R.id.nav_view);
        navigationView.setNavigationItemSelectedListener(this);
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

    @Override
    public boolean onCreateOptionsMenu(Menu menu) {
        // Inflate the menu; this adds items to the action bar if it is present.
        getMenuInflater().inflate(R.menu.my_org_prof, menu);
        return true;
    }

    @Override
    public boolean onOptionsItemSelected(MenuItem item) {
        // Handle action bar item clicks here. The action bar will
        // automatically handle clicks on the Home/Up button, so long
        // as you specify a parent activity in AndroidManifest.xml.
        int id = item.getItemId();

        //noinspection SimplifiableIfStatement
        if (id == R.id.action_settings) {
            return true;
        }

        return super.onOptionsItemSelected(item);
    }

    @SuppressWarnings("StatementWithEmptyBody")
    @Override
    public boolean onNavigationItemSelected(MenuItem item) {
        // Handle navigation view item clicks here.
        int id = item.getItemId();

        if (id == R.id.nav_camera)
        {
            Intent intent = new Intent(this, ListOfOrg.class);
            startActivity(intent);
            finish();
        }
        else if (id == R.id.nav_gallery)
        {
            Choice perem=new Choice();
            boolean cit=Choice.citezen;
            if (cit) {
                Intent intent = new Intent(this, CitProf.class);
                startActivity(intent);
            }
            else { Intent intent = new Intent(this, MyOrgProf.class);
                startActivity(intent);}

            finish();
        }
        else if (id == R.id.nav_slideshow)
        {
            Intent intent = new Intent(this, Q_A.class);
            startActivity(intent);
            finish();
        }
        else if (id == R.id.nav_manage)
        {
            Intent intent = new Intent(this, N_menu.class);
            startActivity(intent);
            finish();
        }
        else if (id == R.id.nav_share)
        {
            Close();
        }

        DrawerLayout drawer = (DrawerLayout) findViewById(R.id.drawer_layout);
        drawer.closeDrawer(GravityCompat.START);
        return true;
    }
    boolean ch=false;
    public  void Close()
    {
        AlertDialog.Builder buil = new AlertDialog.Builder(MyOrgProf.this);
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
//    public void Activisms (View view)
//    {
//        Intent intent = new Intent(this, ActivMer.class);
//        startActivity(intent);
//        finish();
//    }
//    public void Need (View view)
//    {
//        Intent intent = new Intent(this, NeedView.class);
//        startActivity(intent);
//        finish();
//    }
}
