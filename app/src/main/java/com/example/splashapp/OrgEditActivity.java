package com.example.splashapp;

import android.content.Context;
import android.content.DialogInterface;
import android.content.Intent;
import android.graphics.Bitmap;
import android.graphics.BitmapFactory;
import android.net.Uri;
import android.support.v7.app.AlertDialog;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.view.View;
import android.widget.ImageView;
import android.widget.TextView;

import com.squareup.picasso.Picasso;

import java.io.File;
import java.io.FileNotFoundException;
import java.io.InputStream;

public class OrgEditActivity extends AppCompatActivity {

    ImageView imageView;
    Bitmap selectedImage;
    Boolean pe = false;
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_org_edit);


        imageView = (ImageView) findViewById(R.id.imageView12);
        if (C_Organization.MyOrg.getImageName()!=null) {
            try {
                imageView.setImageBitmap(C_Organization.MyOrg.getImageHash());
                //Picasso.get().load(C_Citizen.Iam.getImageName()).into(imageView);
            } catch (Exception e) {
                Picasso.get().load(R.mipmap.about_logo).into(imageView);
            }
        }
        else {
            Picasso.get().load(R.mipmap.about_logo).into(imageView);
        }


        TextView textview= (TextView) findViewById(R.id.editText5);
        textview.setText(C_Organization.MyOrg.getNumber());

        textview= (TextView) findViewById(R.id.editText10);
        textview.setText(C_Organization.MyOrg.getAdress());

        textview= (TextView) findViewById(R.id.editText2);
        textview.setText(C_Organization.MyOrg.getEmail());

        textview= (TextView) findViewById(R.id.editText12);
        textview.setText(C_Organization.MyOrg.getAbout());
    }

    public void PhotoEdit(View view) {
        Intent photoPickerIntent = new Intent(Intent.ACTION_PICK);
        photoPickerIntent.setType("image/*");
        startActivityForResult(photoPickerIntent, 0);
    }


    @Override
    protected void onActivityResult(int reqCode, int resultCode, Intent data) {
        super.onActivityResult(reqCode, resultCode, data);


        if (resultCode == -1) {
            try {
                pe = true;
                final Uri imageUri = data.getData();
                final InputStream imageStream = getContentResolver().openInputStream(imageUri);
                selectedImage = BitmapFactory.decodeStream(imageStream);
                imageView.setImageBitmap(selectedImage);
            } catch (FileNotFoundException e) {
                e.printStackTrace();
            }
        }
    }

    public void OrgEditSave(View view)
    {
        Network upd=new Network();
        TextView textview= (TextView) findViewById(R.id.editText5);
        String s=textview.getText().toString();

        try {
            if (!C_Organization.MyOrg.getNumber().equals(s)) {
                C_Organization.MyOrg.setNumber(s);
                upd.UpdOrg(new String[]{"telephone", "tel", s, C_Organization.MyOrg.getId()});
            }
        }
        catch (Exception e)
        {}
            if (pe) {
                upd.updImgae(new String[]{C_Organization.MyOrg.getId()}, selectedImage);
            }

        textview= (TextView) findViewById(R.id.editText10);
        s=textview.getText().toString();

        //if (!C_Organization.MyOrg.getAdress().equals(s)) {
            C_Organization.MyOrg.setAdress(s);
            upd.UpdOrg(new String[]{"adress","adress", s, C_Organization.MyOrg.getId()});
        //}

        textview= (TextView) findViewById(R.id.editText2);
        textview.setText(C_Organization.MyOrg.getEmail());
        s=textview.getText().toString();

        //if (!C_Organization.MyOrg.getEmail().equals(s)) {
            C_Organization.MyOrg.setEmail(s);
            upd.UpdOrg(new String[]{"email","email", s, C_Organization.MyOrg.getId()});
        //}


        textview= (TextView) findViewById(R.id.editText12);
        s=textview.getText().toString();

       // if (!C_Citizen.Iam.getAbout().equals(s)) {
        C_Organization.MyOrg.setAbout(s);
        upd.UpdOrg(new String[]{"description","description", s, C_Organization.MyOrg.getId()});
        //}


        Intent intent = new Intent(this, MyOrgProf.class);
        startActivity(intent);
        finish();
    }

    @Override
    public void onBackPressed() {
        Cancel(MyOrgProf.class);
    }

    public void Cancel(Class<?> t)
    {
        Context c=this;
        Class<?> x=t;
        AlertDialog.Builder adb = new AlertDialog.Builder(this);
        adb.setMessage("Отменить изменения?");
        adb.setNegativeButton("Нет", new DialogInterface.OnClickListener(){
            @Override
            public void onClick(DialogInterface d, int arg1) {
                return;
            };
        });
        adb.setPositiveButton("Да", new DialogInterface.OnClickListener(){
            @Override
            public void onClick(DialogInterface d, int arg1) {
                Intent intent = new Intent(c, t);
                startActivity(intent);
                finish();
            };
        });

        adb.show();
    }

    public  void ToMyProf(View view)
    {
        Cancel(MyOrgProf.class);
    }
    public  void openMenu(View view) { Cancel( MenuView.class); }
    public  void ToListOfOrg(View view)
    {
        Cancel(ListOfOrg.class);
    }
    public void ToLenta(View view)
    {
        Cancel(LentaActivity.class);
    }
    public void ToChats(View view)
    {
        Cancel(ListOfChats.class);
    }

}