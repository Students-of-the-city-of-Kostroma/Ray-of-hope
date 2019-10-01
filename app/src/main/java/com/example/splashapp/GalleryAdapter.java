package com.example.splashapp;

import android.content.Context;
import android.content.Intent;
import android.net.Uri;
import android.support.v7.widget.RecyclerView;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ImageView;

import com.squareup.picasso.Picasso;

import java.util.List;

public class GalleryAdapter extends RecyclerView.Adapter<GalleryAdapter.ViewHolder> {

    private List<String> Image;
    private List<String> Link;
    private Context context;
    private ItemClickListener mClickListener;

    public GalleryAdapter(Context context,List<String> Image,List<String> Link)
    {
        this.Image=Image;
        this.Link=Link;
        this.context=context;
    }

    @Override
    public ViewHolder onCreateViewHolder(ViewGroup parent, int ViewType)
    {
        View v = LayoutInflater.from(parent.getContext())
                .inflate(R.layout.docs_gallery,parent,false);
        return  new ViewHolder(v);
    }

    @Override
    public void onBindViewHolder(ViewHolder  holder, int position) {
        String im=Image.get(position);
        String li=Link.get(position);
        holder.link=li;
        Picasso.get().load(im).into(holder.imageView);
    }

    @Override
    public int getItemCount() {
        return Image.size();
    }

    public class ViewHolder extends RecyclerView.ViewHolder implements View.OnClickListener {
        public String link;
        public ImageView imageView;

        public ViewHolder (View itemView)
        {
            super(itemView);
            imageView =(ImageView) itemView.findViewById(R.id.docprev);
            itemView.setOnClickListener(this);
        }
        @Override
        public void onClick(View view) {
            if (mClickListener != null) mClickListener.onItemClick(view, getAdapterPosition());
        }
    }

    public String getImage(int id) {
        return Image.get(id);
    }

    public String getLink(int id) {
        return Link.get(id);
    }

    public void setClickListener(ItemClickListener itemClickListener) {
        this.mClickListener = itemClickListener;
    }

    public interface ItemClickListener {
        void onItemClick(View view, int position);
    }
}
